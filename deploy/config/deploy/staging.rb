server "", roles: %w{app}

role :app, ""

set :deploy_to, "/var/www/html/sweets"
set :laravel_dotenv_file, "#{release_path}/stage/.env.staging"
set :htaccess_file, "#{release_path}/stage/httpd/.htaccess"

set :branch, ENV["branch"] || "master"
