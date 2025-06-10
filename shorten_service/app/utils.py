import random as rand

def generate_link():

    chars = list("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789")
    chars = rand.sample(chars, 6)
    code = "/" + "".join(chars)

    link = "http://localhost:5002" + code

    # returns both the whole link and the code alone
    return {"link": link,
            "link_code": code}