#!/bin/bash

for ip in $(dig +short chat.openai.com @1.1.1.1; dig +short api.openai.com @1.1.1.1); do
  sudo route -n delete -host $ip 2>/dev/null || true
done

