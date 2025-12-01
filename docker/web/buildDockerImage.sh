#!/bin/bash
VERSION=1.0.0.petitions

docker build --build-arg VERSION=$VERSION -t "mydocker/apache:$VERSION" -f Dockerfile .

