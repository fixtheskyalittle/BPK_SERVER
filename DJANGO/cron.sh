#!/bin/bash

while true; do
  curl http://localhost:8000/ajax/cron/ 
  sleep 120;
done
