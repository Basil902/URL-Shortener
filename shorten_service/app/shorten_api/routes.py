from flask import jsonify, request
from . import shorten_api_blueprint
from .. import db
from models import ShortURL
from utils import generate_link

@shorten_api_blueprint.route('/shorten', methods=["POST"])
def shorten():

    try:

        user_input = request.form["userInput"]
        user_id = request.form["userID"]

        if not user_input.startswith("https://"):
            return jsonify({"message": "Invalid link. Please enter a valid link that starts with 'https://'"}), 400
        
        link_exists = ShortURL.objects(original_link=user_input, user_id=user_id)

        if link_exists:
            return jsonify({"message": "The submitted link has already been shortened before.",
                            "short_link": link_exists}), 400
        
        # generate_link() returns a dict with the keys "code" and "link".
        new_link = generate_link()
        code = new_link["code"]

        if not new_link:
            return jsonify({"message": "Failed to generate new link"}), 400
        
        # store newly created link in db
        new_link = ShortURL(short_code=code, original_link=user_input, user_id=user_id).save()


        # return the whole generated link
        return jsonify({"message": "Successfully genereated link!",
                        "generated_link": new_link["link"]}), 200
    
    except Exception as e:
        print("Exception inside shorten route: ", e)
        return jsonify({"message": f"An exception occurred: {str(e)}"}), 500