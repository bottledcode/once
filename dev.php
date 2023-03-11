<?php

echo "Gathering secrets and generating required parameters...\n";
$secrets = json_decode(`kubectl get secret swytch-once -o json`, true);
$secrets = array_map(fn($secret) => base64_decode($secret), $secrets['data']);

$currentCluster = explode('_', `kubectl config current-context`)[1];
$currentCluster = explode('-', $currentCluster)[1];

passthru(
	"devspace dev --var STATE_SECRET='{$secrets['state-secret']}' " .
	"--var RETHINKDB_PASSWORD='{$secrets['rdb-password']}' " .
	"--var AUTH_LOGIN='https://fake-auth.{$currentCluster}.once.getswytch.com/login' " .
	"--var AUTH_URL='https://fake-auth.{$currentCluster}.once.getswytch.com/api/auth' " .
	"--var HOST='{$currentCluster}.once.getswytch.com' " .
	"--var AUTH_HOST='fake-auth.{$currentCluster}.once.getswytch.com' "
);
passthru('devspace reset pods');
