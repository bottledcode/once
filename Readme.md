# Say it securely, once and for all

Send secure, self-destructing messages that can only be read once and must be read within a specific time frame.

Check it out on [once.getswytch.com](https://once.getswytch.com/).

## Development

Add a `deployment.values.yaml` file to the root of the project with the following content:

```yaml
secrets:
  stateSecret: a secret string
image: registry.bottled.codes/swytch/once

rethinkdb:
  host: rethinkdb.host
  db: swytch-once
  user: once
  password: a password
```

Then install loft CLI and Devspace:

```bash
loft use space MY-SPACE
devspace deploy
devspace dev
```
