from flask import jsonify, request
from . import shorten_api_blueprint
from .. import db
from ..models import ShortURL
from ..utils import generate_link

@shorten_api_blueprint.route('/shorten', methods=["POST"])
def shorten():

    try:
        # remove white spaces from the entered link
        user_input = request.form["userInput"].strip()
        user_id = request.form["userID"]

        print("input is:", user_input)
        if not user_input.startswith("https://"):
            return jsonify({"message": "Invalid input. Please enter a valid link that starts with 'https://'"}), 422
        
        link_exists = ShortURL.objects(original_link=user_input, user_id=user_id).first()

        # falls link bereits gekürutz würde, diesen dem User anzeigen
        if link_exists:
            link = "http://localhost:5002" + link_exists.short_code
            return jsonify({"message": f"The submitted link has already been shortened before: {link}"}), 409
        
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

# API for returning the stored links of a user
@shorten_api_blueprint.route('/api/getlinks/<int:userID>')
def getlinks(userID):

    try:

        # die Links in asbteigender Reihenfolge holen
        links = ShortURL.objects(user_id=userID).only('short_code').order_by('-created_at')
        # gib die gefundenen Links in einer Liste zurück
        user_links = []

        if not links:
            return jsonify({"message": "No links found"}), 400
        
        for link in links:
            user_links.append("localhost:5002" + link.short_code)
        
        return jsonify({"user_links": user_links}), 200
    
    except Exception as e:
        print("error in get links route: ", e)
        return jsonify({"message": "An exception occurred while trying to fetch links"}), 500