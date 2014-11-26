#!/bin/bash

NAME="openestate_php_wrapper"
VERSION="0.6-SNAPSHOT"
PROJECT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

rm -Rf $PROJECT_DIR/release
mkdir $PROJECT_DIR/release
cd $PROJECT_DIR/src
zip -r $PROJECT_DIR/release/$NAME-$VERSION.zip .
