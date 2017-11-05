import urllib, json
import pprint

# IDs for countries and data types retrieved from the database
countries = ["ID", "IN", "RW", "GB"]
indicators = ["SE.ADT.LITR.ZS", "SG.LAW.CHMR", "SH.STA.MMRT", "SL.EMP.1524.SP.FE.NE.ZS", "SP.MTR.1519.ZS"]

# retrieves the worldbank data for given country and indicator as json.
def fetch_data(indicator, country):
	url = "http://api.worldbank.org/countries/" + country
	url += "/indicators/" + indicator + "?format=json"
	response = urllib.urlopen(url)
	json_file = json.loads(response.read())
	return json_file

# load all required data from worldbank database, return as array of json.
def load_all_data():
	datas = []

	for c in countries:
		for i in indicators:
			datas.append(fetch_data(i, c))

	return datas
