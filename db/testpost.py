import requests

url = 'http://localhost/opa/db/delete_config.php'
myobj = {'cfgid':'18'}

x = requests.post(url, data = myobj)

print(x.content)