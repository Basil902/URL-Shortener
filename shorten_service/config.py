import os
from dotenv import load_dotenv

dotenv_path = os.path.join(os.path.dirname(__file__), '.env')
if os.path.exists(dotenv_path):
    load_dotenv(dotenv_path)

class DevelopmentConfig():
    ENV = "development"
    DEBUG = True
    MONGODB_SETTINGS = {
        'db': 'shorten_service_dev',
        'host': 'host.docker.internal',
        'port': 27017,
        'alias': 'default',
    }
    
class ProductionConfig():
    ENV = "production"
    DEBUG = False
    MONGODB_SETTINGS = {
        'db': 'shorten_service',
        'host': 'host.docker.internal',
        'port': 27017,
        'alias': 'default',
    }