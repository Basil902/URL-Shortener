from flask import jsonify, redirect
import requests
from . import redirect_api_blueprint

shorten_service_url = "http://shorten-service:5001/getlink"

@redirect_api_blueprint.route('/<string:code>')
def redirect_api(code):

    try:
        response = requests.get(shorten_service_url, params={'link_code': f"/{code}"})
        # raise error if bad status code
        response.raise_for_status()
        response = response.json()

        if not response["redirect_link"]:
            return jsonify({"message": "Link not found"}), 409
        
        return redirect(response["redirect_link"])
    
    except requests.exceptions.RequestException as e:
        return jsonify({"error": str(e)}), 500
    
    except Exception as e:
        print("Exception in redirect route: ", e)
        return jsonify({"message": f"Exception {str(e)}"}), 500