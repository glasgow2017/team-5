import json
import mysql.connector
import fetch_data

#List will have all the keys, the ones inside inner lists are
#refering to the keys inside the dictionary refered to by a key.
list_of_keys = []

#Function finding all the keys; if a key refers to a dictionary, this function
#places a keys for this particular dictionary into a a new list inside the "mother" list.
def checking_inside_of_dict(dictionary_input, current_list):
    for keys in dictionary_input:
        #if the element is a dictionary, create a new list on the current place
        #in the current list and call the checking procedure on that list.
        current_list.append(str(keys))
        if (type(dictionary_input[keys]) == dict):
            current_list.append([])
            checking_inside_of_dict(dictionary_input[keys], (current_list[len(current_list)-1]))




#MAIN
#DDDDDDDDDDDDDDDisabled
#filename = raw_input("Type the filename you want me to open: ")
#filename = "india_literacy.json"
#with open(filename) as f:
#    string_file  = json.loads(f.read())[1]

data = fetch_data.load_all_data()

string_file = fetch_data.load_all_data()[1]
print string_file[0]
print string_file[1]

#Calling the function finding
checking_inside_of_dict(string_file[0], list_of_keys)
print list_of_keys
print string_file[0][list_of_keys[0]]
    
String_for_SQL = ""
    
print(len(string_file))
