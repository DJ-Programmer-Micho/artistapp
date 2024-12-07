import pandas as pd
import sys

def convert_tsv_to_csv(tsv_file):
    csv_file = tsv_file.replace(".tsv", ".csv")
    csv_table = pd.read_table(tsv_file, sep='\t', dtype={"isAdult": object, "startYear": object, "isOriginalTitle": object})
    csv_table.to_csv(csv_file, index=False, encoding='utf-8-sig')
    print(f"Converted {tsv_file} to {csv_file}")
    return csv_file

if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("Usage: python convert_tsv_to_csv.py <path_to_tsv_file>")
        sys.exit(1)
    
    tsv_file = sys.argv[1]
    csv_file = convert_tsv_to_csv(tsv_file)
    sys.exit(0)
