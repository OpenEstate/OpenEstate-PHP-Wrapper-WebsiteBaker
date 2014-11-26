#!/bin/bash

NAME="openestate-php-wrapper"
VERSION="0.3"
PROJECT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

rm -Rf $PROJECT_DIR/release
mkdir $PROJECT_DIR/release
cd $PROJECT_DIR/src
zip -r $PROJECT_DIR/release/$NAME-$VERSION.zip .
