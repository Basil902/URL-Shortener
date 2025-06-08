import os
from dotenv import load_dotenv

dotenv_path = os.path.join(os.path.dirname(__file__), '.env')
if os.path.exists(dotenv_path):
    load_dotenv(dotenv_path)

class DevelopmentConfig():
    ENV = "development"
    DEBUG = True
    MONGO_URI = "mongodb://shorten_service_dev:27017"

class ProductionConfig():
    ENV = "production"
    DEBUG = False
    MONGO_URI = "mongodb://shorten_service:27017"