# config valid only for current version of Capistrano
#lock "3.10.0"

set :application, "sweets"
set :repo_url, "git@bitbucket.org:iflag-bitbucket/sweets_server.git"
# set :branch, ENV["branch"] || "master"

# Default value for linked_dirs is []
append :linked_dirs,
'storage/app',
'storage/framework/cache',
'storage/framework/sessions',
'storage/framework/views',
'storage/logs'

# Default value for keep_releases is 5
set :keep_releases, 5

# Defining Composer tasks
namespace :server do
  desc "Preparation"
  task :prepare do
    on roles(:app) do
      within shared_path do
        execute :mkdir, "-p tmp"
      end
    end
  end
end

# Defining Composer tasks
namespace :composer do
  desc "Running Composer Install"
  task :install do
    on roles(:app) do
      within release_path do
        execute :composer, "install --no-dev --quiet --prefer-dist --optimize-autoloader"
      end
    end
  end
  task :link_vendor do
    on roles(:app) do
      within shared_path do
        execute :ln, "-s #{shared_path}/vendor #{release_path}/vendor"
      end
    end
  end
end

# Defining Laravel tasks
namespace :laravel do
  task :fix_permission do
    user = fetch(:server_user)
    on roles(:app) do
      # execute :chown, "-R #{user}:apache #{shared_path}/storage/ #{release_path}/bootstrap/cache/"
      execute :chmod, "-R 775 #{shared_path}/storage/ #{release_path}/bootstrap/cache/"
    end
  end
  task :configure_dot_env do
    dotenv_file = fetch(:laravel_dotenv_file)
    on roles (:app) do
      execute :ln, "-s -f #{dotenv_file} #{release_path}/.env"
    end
  end
  task :configure_htaccess do
    htaccess_file = fetch(:htaccess_file)
    on roles (:app) do
      execute :ln, "-s -f #{htaccess_file} #{release_path}/public/.htaccess"
    end
  end
  task :optimize do
    on roles(:app) do
      within release_path do
        execute :php, "artisan clear-compiled"
        execute :php, "artisan optimize"
      end
    end
  end
  task :migrate do
    on roles(:app) do
      within release_path do
        execute :php, "artisan migrate --no-interaction --force"
      end
    end
  end
  task :seed do
    on roles(:app) do
      within release_path do
        execute :php, "artisan db:seed --no-interaction --force"
      end
    end
  end
  task :symlink_tmp do
    on roles(:app) do
      within shared_path do
        execute :ln, "-s #{shared_path}/tmp #{release_path}/public/tmp"
      end
    end
  end
end

# Defining Node tasks
namespace :node do
  desc "Running yarn install"
  task :install do
    on roles(:app) do
      within release_path do
        execute :cp, "package.json #{shared_path}"
      end
      within shared_path do
        execute :yarn, "install"
      end
    end
  end
  task :link_node_modules do
    on roles(:app) do
      within shared_path do
        execute :ln, "-s #{shared_path}/node_modules #{release_path}/node_modules"
      end
    end
  end
end

# Defining Gulp tasks
namespace :gulp do
  task :build do
    on roles(:app) do
      within release_path do
        execute :gulp, "--production"
        execute :gulp, "versioning"
      end
    end
  end
end

# Defining chmod monitor tasks
namespace :chmod do
  task :monitor do
    on roles(:app) do
      within release_path do
        execute :chmod, "-R 744 utilities/monitoring/init_monitor_log.sh"
        execute :chmod, "-R 744 utilities/monitoring/init_monitor_log.sh"
        execute :chmod, "-R 744 utilities/monitoring/init_monitor_log.sh"
      end
    end
  end
end

namespace :deploy do
  before :starting, "server:prepare"
  after :updated, "composer:install"
  after :updated, "laravel:configure_dot_env"
  after :updated, "laravel:configure_htaccess"
  after :updated, "laravel:symlink_tmp"
  after :updated, "laravel:optimize"
  #after :updated, "laravel:migrate"
  #after :updated, "laravel:seed"
  after :updated, "node:install"
  after :updated, "node:link_node_modules"
  after :updated, "gulp:build"
  after :updated, "chmod:monitor"
end
