from pathlib import Path
import shutil


FRONTEND_ROOT = Path('./frontend/dist')
PLUGIN_ROOT = Path('./nillkizz-appointment')

plugin_app_dir = PLUGIN_ROOT / 'public' / 'app'

def clear_plugin_app():
    if plugin_app_dir.exists():
        shutil.rmtree(plugin_app_dir)

def create_plugin_app_dir():
    plugin_app_dir.mkdir(parents=True)

def copy_app_staticfiles_to_plugin():
    shutil.copytree((FRONTEND_ROOT /'js').resolve(), (plugin_app_dir / 'js' ).resolve())


def make_archive():
    shutil.make_archive('nillkizz-appointment', 'zip', 'nillkizz-appointment')

clear_plugin_app()
create_plugin_app_dir()
copy_app_staticfiles_to_plugin()
make_archive()