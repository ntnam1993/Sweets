server "sweet-staging2", roles: %w{app}

role :app, %w{sweet-staging2}

set :deploy_to, "/var/www/html/sweets"
set :laravel_dotenv_file, "#{release_path}/stage/.env.staging"
set :htaccess_file, "#{release_path}/stage/httpd/.htaccess"

set :branch, ENV["branch"] || "master"
