# Laravel Horizon Local

Run Laravel Horizon locally to monitor your queued jobs on the server using SSH port forwarding.

I've found it useful in cases where I don't want to publish assets and create web routes for an API-only application. 

## Prerequisite 

If you don't use an SSH configuration files, google "SSH config file". For example, your `~/.ssh/config` may have the
 following entry:

```
Host staging-2
    Hostname 10.10.10.10
    User ec2-user
    PreferredAuthentications publickey
    IdentityFile "/Users/johndoe/.ssh/id_rsa"
```

## Usage

1. Clone this repository.

```
git clone git@github.com:koomai/laravel-horizon-local.git
```

2. Install dependencies and publish Horizon assets.

```
composer install
php artisan horizon:install
```

3. Add local and remote ports to your Redis instance in your `.env` file (if different from the defaults below):

```
REDIS_HOST=127.0.0.1
REDIS_PORT=6380

REMOTE_REDIS_HOST=127.0.0.1
REMOTE_REDIS_PORT=6379
```

4. Run the artisan command below to start the SSH tunnel to your remote server as defined in your configuration file, e.g. `staging-2`

```
php artisan ssh:tunnel staging-2
```

5. Run `php artisan serve` (or see [Laravel Valet](https://laravel.com/docs/5.8/valet) if you're using MacOS). 

6. Go to `<your url>/horizon` on your browser to view your remote queued jobs.
