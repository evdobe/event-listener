# Skeleton project

This is a skeleton for evdobe projects.

Prerequisites:

- Bash shell
- Docker Compose

## Project structure

### bin

Executable bash scripts - docker compose wrappers for manupulating different conainerized environments.

Available commands:
- build < environment > : Build environment images
- up < environment > [options] [services] : Bring up environment services
- down < environment > [options] [services]: Bring down envrinment services
- start < environment > < service > : Start a service
- stop < environment > < service > : Stop a service
- restart < environment > < service > : Restart a service
- exec < environment > < service > [options] : Execute in a service

### dev

The place where development happens. Put here your project's source code.

### ops

Here go the specifications of conteinerized environments for your project:

- ops/cont: Container building stuff like Dockerfiles, configuration and filesystem targets.
- ops/comp: Docker Compose runtime stuff like docker-compose.yaml, environment variables file (.env) and container mounts.

## Hello World 

On a bash terminal run:

```bin/up dev```

A docker hello-world based container image will be built, tagged as ```evdobe-skeleton_hello-world:latest``` and executed with service name ```hello-world```
 
