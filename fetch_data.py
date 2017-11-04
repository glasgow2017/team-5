import urllib, json


def fetch_data(indicator, country):
	url = "http://api.worldbank.org/countries/" + country
	url += "/indicators/" + indicator + "?format=json"
	response = urllib.urlopen(url)
	json_file = json.loads(response.read())
	return json_file

countries = ["ID", "IN", "RW", "GB"]
indicators = ["SE.ADT.LITR.ZS", "SG.LAW.CHMR", "SH.STA.MMRT", "SL.EMP.1524.SP.FE.NE.ZS", "SP.MTR.1519.ZS"]

datas = []

for c in countries:
	for i in indicators:
		datas.append(fetch_data(i, c))

print(len(datas))
