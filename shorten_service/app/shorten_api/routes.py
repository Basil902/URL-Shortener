from flask import jsonify, request
from . import shorten_api_blueprint
from .. import db
from ..models import ShortURL
from ..utils import generate_link

@shorten_api_blueprint.route('/shorten', methods=["POST"])
def shorten():

    try:
        user_input = request.form["userInput"]
        user_id = request.form["userID"]

        if not user_input.startswith("https://"):
            return jsonify({"message": "Invalid input. Please enter a valid link that starts with 'https://'"}), 400
        
        link_exists = ShortURL.objects(original_link=user_input, user_id=user_id)

        if link_exists:
            return jsonify({"message": "The submitted link has already been shortened before.",
                            "short_link": link_exists}), 409
        
        # generate_link() returns a dict with the keys "code" and "link".
        new_link = generate_link()
        code = new_link["link_code"]

        if not new_link:
            return jsonify({"message": "Failed to generate new link"}), 400
        
        # store newly created link code and original link in database
        success = ShortURL(short_code=code, original_link=user_input, user_id=user_id).save()

        if not success:
            return jsonify({"message": "Error occurred while trying to insert into database."}), 500

        # return the whole generated link
        return jsonify({"message": "Successfully genereated link!",
                        "generated_link": new_link["link"]}), 200
    
    except Exception as e:
        print("Exception inside shorten route: ", e)
        return jsonify({"message": f"An exception occurred: {str(e)}"}), 500
    
# endpoint for checking if a given link exists in the DB, if so redirect user to the corresponding original link
@shorten_api_blueprint.route('/getlink')
def getlink():

    link_code = request.args.get("link_code")

    link_exists = ShortURL.objects(short_code=link_code).first()

    if not link_exists:
        return jsonify({"message": "Link doesn't exist."}), 400
    
    return jsonify({"redirect_link": link_exists.original_link}), 200