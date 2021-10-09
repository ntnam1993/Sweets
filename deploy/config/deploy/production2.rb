server "sweet-production2", roles: %w{app}

role :app, %w{sweet-production2}

set :deploy_to, "/var/www/html/sweets"
set :laravel_dotenv_file, "#{release_path}/prod/.env.production"
set :htaccess_file, "#{release_path}/prod/httpd/.htaccess"

set :branch, ENV["branch"] || "master"
