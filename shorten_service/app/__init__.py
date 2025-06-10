import config
import os
from flask import Flask
from flask_mongoengine import MongoEngine

db = MongoEngine()

def create_app():
    app = Flask(__name__)
    # load configuartion dynamically (production, development etc) see .env
    environment_configuration = os.environ['CONFIGURATION_SETUP']
    # apply configuration to app
    app.config.from_object(environment_configuration)

    db.init_app(app)

    with app.app_context():
        from .shorten_api import shorten_api_blueprint
        app.register_blueprint(shorten_api_blueprint)
        return app