import config
import os
from flask import Flask

def create_app():
    app = Flask(__name__)
    environment_configuration = os.environ['CONFIGURATION_SETUP']
    app.config.from_object(environment_configuration)

    with app.app_context():
        # register blueprint
        from .redirect_api import redirect_api_blueprint
        app.register_blueprint(redirect_api_blueprint)
        return app