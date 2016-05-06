## Configration générale
# L'adresse de PHP pour 1&1
set :php_bin, "/usr/bin/php5.5-cli -dmemory_limit=1G"
set :composer_options,  "--no-dev --verbose --prefer-dist --optimize-autoloader --no-progress"
set :update_vendors, true
set :copy_vendors, true
# le nom de l'application
set :application, "facebook"
# le domaine sur lequel capifony se connecte en ssh
set :domain, "u84788749.1and1-data.host"
# Le nom d’utilisateur du serveur distant
set :user, "u84788749"
# Le répertoire de destination
set :deploy_to, "facebook"

role :web, domain
role :app, domain, :primary => true
set :use_sudo, false

# La configuration du dépôt, ici avec git
set :scm, :git
set :deploy_via, :copy
set :repository, "git@github.com:ShihoWasTaken/facebook_symfony.git"
set :deploy_via, :copy

# Le nombre de releases à garder après un déploiement réussi
set :keep_releases, 5

## Configration spécifique Symfony2
# Les fichiers à conserver entre chaque déploiement
set :shared_files, ["app/config/parameters.yml"]

# Idem, mais pour les dossiers
set :shared_children, [app_path + "/logs", "vendor"]
set :use_composer, true
# Application des droits nécessaires en écriture sur les dossiers
set :writable_dirs, ["app/cache", "app/logs"]

set :use_set_permissions, true
# dumper les assets
set :dump_assetic_assets, true

# Augmenter le niveau de détail des logs rend le déploiement plus facile à déboguer en cas d'erreurs.
logger.level = Logger::MAX_LEVEL

module UseScpForDeployment
  def self.included(base)
    base.send(:alias_method, :old_upload, :upload)
    base.send(:alias_method, :upload,     :new_upload)
  end

  def new_upload(from, to)
    old_upload(from, to, :via => :scp)
  end
end

Capistrano::Configuration.send(:include, UseScpForDeployment)