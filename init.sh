#!/bin/bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"

if [ -z $1 ]; then
    echo "Usage: ./init.sh <VERSION>"
    exit 0
fi

VERSION=$1

rm -rf $DIR/icms2
rm -rf $DIR/mysql/db/*
echo '' > $DIR/mysql/db/.gitkeep

echo "Downloading InstantCMS v$VERSION..."
git clone -q --branch $VERSION https://github.com/instantsoft/icms2.git || { 
    echo 'Failed to download. Bad version?' ; exit 1; 
}

echo "Cleaning repository stuff..."
rm -rf $DIR/icms2/.git
rm -rf $DIR/icms2/.github
rm -rf $DIR/icms2/.gitignore
rm -f $DIR/icms2/ISSUE_TEMPLATE.md
rm -f $DIR/icms2/README.md
rm -f $DIR/icms2/README_RU.md
rm -f $DIR/icms2/LICENSE

echo "Setting up permissions..."
find $DIR/icms2/ -type f -exec chmod 644 {} \;
find $DIR/icms2/ -type d -exec chmod 755 {} \;
chmod -R 777 $DIR/icms2/upload
chmod -R 777 $DIR/icms2/cache
chmod 777 $DIR/icms2/system/config

echo "Starting Docker..."
docker-compose up
