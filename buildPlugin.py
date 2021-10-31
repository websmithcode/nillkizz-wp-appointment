from pathlib import Path
import shutil


FRONTEND_INDEX = Path(
    './frontend/dist/index.html')
FRONTEND_ROOT = Path(
    './frontend/dist/wp-content/plugins/nillkizz-appointment/public/app/')
PLUGIN_ROOT = Path('./nillkizz-appointment')

plugin_app_dir = PLUGIN_ROOT / 'public' / 'app'


def clear_plugin_app():
    if plugin_app_dir.exists():
        shutil.rmtree(plugin_app_dir)


def copy_app_staticfiles_to_plugin():
    shutil.copytree((FRONTEND_ROOT).resolve(),
                    (plugin_app_dir).resolve())
    shutil.copy((FRONTEND_INDEX).resolve(),
                (plugin_app_dir).resolve())


def make_archive():
    shutil.make_archive('nillkizz-appointment', 'zip', 'nillkizz-appointment')


clear_plugin_app()
copy_app_staticfiles_to_plugin()
# make_archive()
