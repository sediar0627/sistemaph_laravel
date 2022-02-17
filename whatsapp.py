from flask import Flask
import requests
import json
import webbrowser as wb, time as tm, pyautogui as pg

app = Flask(__name__)

host = "https://sistemaph.sideso.com.co/notificaciones/pendientes/whatsapp"

def enviar_whatsapp(telefono, mensaje):
    screenWidth, screenHeight = pg.size()
    wb.open("https://web.whatsapp.com/send?phone=+57" + telefono);
    tm.sleep(8)
    pg.moveTo(((screenWidth/2) + 100), (screenHeight - 70))
    pg.click()
    pg.write(mensaje);
    pg.press("enter");
    tm.sleep(5)
    pg.hotkey("ctrl", "w");

@app.route('/')
def mensajes():
    pendientes_request = requests.post(host)
    pendientes = json.loads(pendientes_request.content)

    for notificacion in pendientes:
        enviar_whatsapp(notificacion["telefono"], notificacion["mensaje"])
        requests.post(host + '/' + str(notificacion["id"]))

    tm.sleep(10)
    mensajes()

    return "SISTEMA PH"

if __name__ == '__main__':
    app.run(
        host="0.0.0.0",
        port="2000",
        debug=True
        )
