from flask import Blueprint

redirect_api_blueprint = Blueprint("redirect_api", __name__)

from . import routes