<?php

//passthru('loft use vcluster');
//passthru('devspace use namespace once');

echo "Gathering secrets and generating required parameters...\n";
$secrets = json_decode(`kubectl get secret swytch-once -o json`, true);
$secrets = array_map(fn($secret) => base64_decode($secret), $secrets['data']);

echo "Secrets:\n";
foreach ($secrets as $key => $secret) {
	echo "  $key: $secret\n";
}

$currentCluster = explode('_', `kubectl config current-context`)[1];
$currentCluster = explode('-', $currentCluster)[1];

$deployed = json_decode(`kubectl get pods -o json`, true);
$tag = explode(':', $deployed['items'][0]['spec']['containers'][0]['image'], 2)[1];

echo "Deployed tag: $tag\n";

$cacheFile = __DIR__ . '/.devspace/cache.yaml';
$config = file_exists($cacheFile) ? yaml_parse_file($cacheFile) : [];
$config['images']['once']['tag'] = $tag;
yaml_emit_file(__DIR__ . '/.devspace/cache.yaml', $config);

passthru(
	"devspace dev --force-deploy --skip-build -t  $tag " .
	"--var STATE_SECRET='{$secrets['state-secret']}' " .
	"--var RETHINKDB_PASSWORD='{$secrets['rdb-password']}' " .
	"--var AUTH_LOGIN='https://fake-auth.{$currentCluster}.once.getswytch.com/login' " .
	"--var AUTH_URL='https://fake-auth.{$currentCluster}.once.getswytch.com/api/auth' " .
	"--var HOST='{$currentCluster}.once.getswytch.com' " .
	"--var AUTH_HOST='fake-auth.{$currentCluster}.once.getswytch.com' " .
	"--var PROBES=false"
);
passthru('devspace reset pods');
