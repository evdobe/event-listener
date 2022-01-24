#!/bin/sh
if [ -f vendor/bin/behat ]; then
    runuser -l hostuser vendor/bin/behat --init
fi