<?php

echo "Gathering secrets and generating required parameters...\n";
$secrets = json_decode(`kubectl get secret swytch-once -o json`, true);
$secrets = array_map(fn($secret) => base64_decode($secret), $secrets['data']);

$currentCluster = explode('_', `kubectl config current-context`)[1];
$currentCluster = explode('-', $currentCluster)[1];

$tag = `git rev-parse HEAD`;
$config = yaml_parse_file(__DIR__.'/.devspace/cache.yaml');
$config['images']['once']['tag'] = $tag;
yaml_emit_file(__DIR__.'/.devspace/cache.yaml', $config);

passthru(
	"devspace dev --force-deploy --skip-build -t  $tag" .
	"--var STATE_SECRET='{$secrets['state-secret']}' " .
	"--var RETHINKDB_PASSWORD='{$secrets['rdb-password']}' " .
	"--var AUTH_LOGIN='https://fake-auth.{$currentCluster}.once.getswytch.com/login' " .
	"--var AUTH_URL='https://fake-auth.{$currentCluster}.once.getswytch.com/api/auth' " .
	"--var HOST='{$currentCluster}.once.getswytch.com' " .
	"--var AUTH_HOST='fake-auth.{$currentCluster}.once.getswytch.com' " .
	"--var PROBES=false"
);
passthru('devspace reset pods');
