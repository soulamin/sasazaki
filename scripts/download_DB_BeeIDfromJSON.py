# Antes de rodar este comando é aconselhável atualizar o db do servidor da BeeID com o comando: /offlineDbSetup
import requests
import mysql.connector
import json



group_images = []
not_column = ['_id','id','environmentImages', 'simulatedProduct', 'Created_date', '__v', 'relatedImages', 'relatedImagesLandscape', 'favorites','resistencia_mecânica']

mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    password="",
    database="portobello"
)

mycursor = mydb.cursor()

url = 'http://54.210.15.64:3000/products'

sql = "DELETE from produtos"
mycursor.execute(sql)
mydb.commit()

sql = "DELETE from environment_images"
mycursor.execute(sql)
mydb.commit()

sql = "DELETE from related_images"
mycursor.execute(sql)
mydb.commit()

sql = "DELETE from related_images_landscape"
mycursor.execute(sql)
mydb.commit()

sql = "DELETE from group_images"
mycursor.execute(sql)
mydb.commit()

with open('fernando.json', 'r') as f:
    x = json.loads(f.read())

if(True):
    for jsonIten in x:
        sql = 'insert into produtos '
        coluna = '('
        valores = '('
        for column in jsonIten:
            if column not in not_column:
                if column != 'zoom_image':
                    coluna = coluna + column+','
                else:
                    coluna = coluna + 'zoomImage'+','
                value = str(jsonIten[column]).replace('\"',"\\\"")
                valores = valores+ '\"' + value.replace(",",".")+'\"'+','

        coluna = coluna[:-1] + ')'
        valores = valores[:-1] + ')'

        sql = sql + coluna + 'values' + valores

        mycursor.execute(sql)
        mydb.commit()

        createdId = mycursor.lastrowid
        for column in jsonIten:
            if column == 'environmentImages':
                for semicolumn in jsonIten[column]:
                    sql = 'insert into environment_images (cod_produto, sufixo, environmentImage) values (\"'+jsonIten['cod_produto']+'\","'+jsonIten['sufixo']+'\",\"'+semicolumn+'\")'
                    mycursor.execute(sql)
                    mydb.commit()
            if column == 'relatedImages':
                for semicolumn in jsonIten[column]:
                    if semicolumn is not None:
                        sql = 'insert into related_images (cod_produto, sufixo, relatedImage) values (\"'+jsonIten['cod_produto']+'\","'+jsonIten['sufixo']+'\",\"'+semicolumn+'\")'
                        mycursor.execute(sql)
                        mydb.commit()
            if column == 'relatedImagesLandscape':
                for semicolumn in jsonIten[column]:
                    if semicolumn is not None:
                        sql = 'insert into related_images_landscape (cod_produto, sufixo, relatedImageLandscape) values (\"'+jsonIten['cod_produto']+'\","'+jsonIten['sufixo']+'\",\"'+semicolumn[semicolumn.find('/data'):]+'\")'
                        mycursor.execute(sql)
                        mydb.commit()
            if column == 'zoom_image':
                pass

            if jsonIten['groupColor'] not in group_images:
                try:
                    sql = 'insert into group_images (mainImage, id) values (\"'+jsonIten['zoom_image']+'\","'+jsonIten['groupColor']+'\")'
                    mycursor.execute(sql)
                    mydb.commit()
                    group_images.append(jsonIten['groupColor'])
                except:
                    print("zoom_image do produto {} não encontrada".format(jsonIten['cod_produto']))


mycursor.execute('update produtos set enableforrevenda=\'1\'')
mydb.commit()

 