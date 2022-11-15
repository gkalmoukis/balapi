#!/bin/bash
openapi bundle docs/main.yaml -o public/docs/openapi.yaml
redoc-cli bundle docs/main.yaml
mv redoc-static.html public/docs/index.html
xclip -sel c < public/docs/openapi.yaml