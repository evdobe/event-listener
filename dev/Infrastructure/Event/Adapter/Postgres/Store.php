<?php declare(strict_types=1);

namespace Infrastructure\Event\Adapter\Postgres;

use Application\Event\Mapper;
use Application\Event\Store as EventStore;
use Application\Messaging\Message;
use PDO;

class Store implements EventStore
{

    protected PDO $con;

    protected const UPDATE_EVENT_SQL = 'INSERT INTO 
        event(source_id, "name", channel, correlation_id, user_id, aggregate_id, aggregate_version, "data", "timestamp", "received_at") 
        VALUES (:source_id, :name, :channel, :correlation_id, :user_id, :aggregate_id, :aggregate_version, :data, :timestamp, NOW())';

    public function __construct(protected Mapper $mapper)
    {
        if (getenv('LOG_LEVEL') === 'debug'){
            echo "PDO params:";
            var_dump("pgsql:host=".getenv('STORE_DB_HOST').";port=" . (getenv('DB_PORT') ?: '5432').";dbname=".getenv('STORE_DB_NAME').(getenv('STORE_DB_SSL_MODE')?";sslmode=".getenv('STORE_DB_SSL_MODE'):""), getenv('STORE_DB_USER'));
        }
        $this->con = new PDO("pgsql:host=".getenv('STORE_DB_HOST').";port=" . (getenv('DB_PORT') ?: '5432').";dbname=".getenv('STORE_DB_NAME').(getenv('STORE_DB_SSL_MODE')?";sslmode=".getenv('STORE_DB_SSL_MODE'):""), getenv('STORE_DB_USER'), getenv('STORE_DB_PASSWORD'));
    }

    public function add(Message $message, string $channel): void
    {
        $data = $this->mapper->map(message: $message, channel: $channel);
        $statement = $this->con->prepare(self::UPDATE_EVENT_SQL);
        $statement->execute($data);
    }

    public function hasEvent(int|string $sourceId, string $channel, string $timestamp): bool
    {
        $statement = $this->con->prepare('SELECT id FROM event WHERE source_id = :source_id AND channel = :channel AND timestamp = :timestamp');
        $statement->execute([
            ':source_id' => $sourceId,
            ':channel' => $channel,
            ':timestamp' => $timestamp,
        ]);
        return !empty($statement->fetch());
    }
}
