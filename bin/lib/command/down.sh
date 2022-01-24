#!/bin/bash
PARENT_PATH=$( cd "$(dirname "${BASH_SOURCE[0]}")" ; pwd -P )
source $PARENT_PATH/../lib.sh

docker-compose --env-file $COMPOSE_PATH/.env -f $COMPOSE_PATH/docker-compose.yaml down --remove-orphans $@
