server "", roles: %w{app}

role :app, ""

set :deploy_to, "/var/www/html/sweets_dev"
set :laravel_dotenv_file, "#{release_path}/dev/.env.dev"
set :htaccess_file, "#{release_path}/dev/httpd/.htaccess"

set :branch, ENV["branch"] || "master"
