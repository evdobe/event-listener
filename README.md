# Skeleton project

This is a skeleton for evdobe projects.

Prerequisites:

- Bash shell
- Docker Compose

## Project structure

### bin

Executable bash scripts - docker compose wrappers for manupulating different conainerized environments.

Environment:
```./bin/env ENVIRONMENT COMMAND [OPTIONS]```

COMMAND may be one of:
- build: Build environment images
- up [SERVICES] [OPTIONS]  : Bring up environment services
- down [SERVICES] : Bring down envrinment services
- start [SERVICE] [OPTIONS]: Start services
- stop [SERVICE] : Stop services
- restart [SERVICE] : Restart services
- exec [SERVICE] [options] : Execute in services

### dev

The place where development happens. Put here your project's source code.

### ops/envs

Here go the specifications of conteinerized environments for your project:

- ops/envs/{ENVIRONMENT}/cont: Container building stuff like Dockerfiles, configuration and filesystem targets.
- ops/envs/{ENVIRONMENT}/comp: Docker Compose runtime stuff like docker-compose.yaml, environment variables file (.env) and container mounts.

## Hello World 

On a bash terminal run:

```bin/up dev```

A docker hello-world based container image will be built, tagged as ```evdobe-skeleton_hello-world:latest``` and executed with service name ```hello-world```
 
