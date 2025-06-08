# app/shorten_service/__init__.py
from flask import Blueprint

shorten_api_blueprint = Blueprint("shorten_api", __name__)

from . import routes