#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"

declare -A envs 
envs[VERSION]=2.13.1
envs[HTTP_PORT]=80
envs[PHPMYADMIN_PORT]=8001
envs[MYSQL_DATABASE]=icmsdb
envs[MYSQL_USER]=icmsdb
envs[MYSQL_PASSWORD]=secret
envs[MYSQL_ROOT_PASSWORD]=rootsecret

declare -A prompts
prompts[VERSION]="InstantCMS version to install"
prompts[HTTP_PORT]="Web-server Port"
prompts[PHPMYADMIN_PORT]="PhpMyAdmin Port"
prompts[MYSQL_DATABASE]="MySQL Database"
prompts[MYSQL_USER]="MySQL User"
prompts[MYSQL_PASSWORD]="MySQL User Password"
prompts[MYSQL_ROOT_PASSWORD]="MySQL Root Password"

order=(VERSION HTTP_PORT PHPMYADMIN_PORT MYSQL_DATABASE MYSQL_USER MYSQL_PASSWORD MYSQL_ROOT_PASSWORD)

echo ""
echo -e "\e[96mWelcome to icms2-docker Installation Wizard\e[39m"
echo "Please answer the questions to initialise your installation"
echo ""

for key in "${order[@]}"; do 
    default=${envs[$key]}
    prompt=${prompts[$key]}
    read -p "    $prompt "$'\e[2m['"$default"$']\e[22m: ' answer
    answer=${answer:-$default}
    envs[$key]=$answer
done

echo ""

echo "Saving configuration..."
rm -f $DIR/.env
for key in "${order[@]}"; do 
    echo "$key=${envs[$key]}" >> $DIR/.env
done

VERSION="${envs[VERSION]}"

echo "Cleaning installation..."
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
docker-compose up -d

echo "Done!"
echo ""
