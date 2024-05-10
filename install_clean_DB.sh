#!/bin/bash

vendor/bin/sail mariadb -u vagrant -p < database/migrations/production.sql
