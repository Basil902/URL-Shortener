from . import db
from datetime import timezone
import datetime

class ShortURL(db.Document):
    # der Code in dem gekürztem Link zb abc123 in htpp:shortlink/abc123
    short_code = db.StringField(required=True, unique=True)
    original_link = db.StringField(required=True)
    created_at = db.DateTimeField(default=datetime.datetime.now(timezone.utc))

    # User id should be contained in the request made from Laravel
    user_id = db.IntField(required=True)

    # defines name of collection / table
    meta = {
        'collection': 'short_urls'
    }