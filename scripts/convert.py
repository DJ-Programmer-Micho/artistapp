import pandas as pd 

while True:
	inp_name = input("The name of your .tsv file?? \n")
	if ".tsv" not in inp_name:
		inp_name = inp_name + ".tsv"	
	tsv_file = inp_name.lower().replace(" ", "").replace(",", ".")
	out_name = tsv_file.replace(".tsv", ".csv")
	# tsv_file='title.crew.tsv'
	csv_table=pd.read_table(tsv_file,sep='\t', dtype={"isAdult": object, "startYear": object, "isOriginalTitle": object})
	csv_table.to_csv(out_name,index=False, encoding='utf-8-sig')
	print("Done. \nOff to the next file.")

