#!/bin/bash

#Database credentials
user=""
password=""
host=""
db_name="mydb"

#Path/filename options
backup_path="/home/bitnami/backups/db"
date=$(date "+%d-%b-%Y")
fileName="$db_name-$date.sql"

#Set file permissions
umask 177

#Dump database to SQL file
mysqldump --user=$user --password=$password --host=$host $db_name > $backup_path/$fileName
#Check that backup was successfully created
if [ -f $backup_path/$fileName ]; then
        echo "Database backed up to $backup_path/$fileName."
else
        echo "Database backup unsuccessful."
fi