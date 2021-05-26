# Developed by https://github.com/igormv28
from flask import Flask, g, redirect, url_for, request, redirect
from flask_oidc import OpenIDConnect
import uuid
import os
import logging

def _force_https(wsgi_app):
    def wrapper(environ, start_response):
        environ['wsgi.url_scheme'] = 'https'
        return wsgi_app(environ, start_response)

    return wrapper

app = Flask(__name__)

app.wsgi_app = _force_https(app.wsgi_app)

app.config["OIDC_CLIENT_SECRETS"] = "config.json"
app.config["OIDC_COOKIE_SECURE"] = False
app.config["OIDC_CALLBACK_ROUTE"] = "/oidc/callback"
app.config["SECRET_KEY"] = "b'\x1d \xe5h\xe7~\xd2<\xe9\x92c\xa9\x8b\xad/\x8f'"
app.config['PREFERRED_URL_SCHEME'] = 'https'
oidc = OpenIDConnect(app)



@app.route("/")
@oidc.require_login
def doritos():
    print(request.headers)
    client_id = ""
    client_secret = ""

    # return 'Hello, bem vindo. You are authenticated. %s' % g.oidc_id_token["firstName"]  + '<br>' + \
    #      "<a href = '/logout'>Click here to log out</a>"
    return redirect('http://localhost/main.php?client_id=' + client_id + "&client_secret=" + client_secret, code=302)


@app.route("/logout")
def logout():
    oidc.logout()
    print(request.headers)
    return redirect(url_for(".index"))

#app.run(host='0.0.0.0',port=8080)
app.run(host='0.0.0.0',port=443, debug = True, ssl_context = 'adhoc')
