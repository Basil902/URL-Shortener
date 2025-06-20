import config
import os
from flask import Flask
from flask_mongoengine import MongoEngine
from flask_cors import CORS

# HIER CORS EINRICHTEN ! oider bei unsicherheit deepseek fragen, anfragen von laravel erluaben (port 8000)

db = MongoEngine()

def create_app():
    app = Flask(__name__)
    # load configuartion dynamically (production, development etc) see .env
    environment_configuration = os.getenv('CONFIGURATION_SETUP', 'config.ProductionConfig')
    # apply configuration to app
    app.config.from_object(environment_configuration)
    # CORS einrichten, um Requests von anderen Resources zu erlauben, z.B. aus dem Frontend (port 8000)
    CORS(app, resources={r"/shorten/*": {"origins": "http://localhost*"}}, supports_credentials=True)

    db.init_app(app)

    with app.app_context():
        from .shorten_api import shorten_api_blueprint
        app.register_blueprint(shorten_api_blueprint)
        return app