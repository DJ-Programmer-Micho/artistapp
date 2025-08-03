#!/usr/bin/env python3
import sys
import csv
from datetime import datetime
from pathlib import Path

# Usage: python convert_csv_to_standard_tsv.py input.csv output.tsv
if len(sys.argv) != 3:
    print("Usage: convert_csv_to_standard_tsv.py input.csv output.tsv")
    sys.exit(1)

input_file = Path(sys.argv[1])
output_file = Path(sys.argv[2])

# Input columns expected (original CSV):
# dsp_name, sale_date, release_date, country_of_sale, source_type,
# artist_name, title, quantity, royalties_usd, splits_pct, recoup_usd

# Output headers (13 columns, exact order your PHP expects):
OUT_HEADERS = [
    "Reporting Date",                    # 0 <- release_date (date only)
    "Sale Month",                        # 1 <- sale_date (YYYY-MM)
    "Store",                             # 2 <- dsp_name
    "Artist",                            # 3 <- artist_name
    "Title",                             # 4 <- title
    "ISRC",                              # 5 <- empty
    "UPC",                               # 6 <- empty
    "Quantity",                          # 7 <- quantity
    "Team Percentage",                   # 8 <- 100 (forced)
    "Song/Album",                        # 9 <- source_type
    "Country of Sale",                   #10 <- country_of_sale
    "Songwriter Royalties Withheld",     #11 <- 0 (forced)
    "Earnings (USD)"                     #12 <- royalties_usd
]

def parse_date_only(s: str) -> str:
    if not s:
        return ""
    s = s.strip()
    try:
        return datetime.fromisoformat(s.replace("Z", "")).date().isoformat()
    except Exception:
        return s[:10]

def to_sale_month(s: str) -> str:
    # Return YYYY-MM from YYYY-MM-DD
    if not s:
        return ""
    s = s.strip()
    try:
        d = datetime.fromisoformat(s.replace("Z", "")).date()
        return f"{d.year:04d}-{d.month:02d}"
    except Exception:
        return s[:7]

with input_file.open("r", newline="", encoding="utf-8") as fin, \
     output_file.open("w", newline="", encoding="utf-8") as fout:

    reader = csv.DictReader(fin)
    writer = csv.writer(fout, delimiter="\t", quoting=csv.QUOTE_MINIMAL)

    writer.writerow(OUT_HEADERS)

    for row in reader:
        reporting_date = parse_date_only(row.get("release_date", ""))
        sale_month = to_sale_month(row.get("sale_date", ""))

        out_row = [
            reporting_date,                     # 0
            sale_month,                         # 1
            row.get("dsp_name", ""),            # 2
            row.get("artist_name", ""),         # 3
            row.get("title", ""),               # 4
            "",                                 # 5 ISRC
            "",                                 # 6 UPC
            row.get("quantity", ""),            # 7
            "100",                              # 8 Team Percentage
            row.get("source_type", ""),         # 9
            row.get("country_of_sale", ""),     #10
            "0",                                #11 Songwriter Royalties Withheld
            row.get("royalties_usd", ""),       #12
        ]
        writer.writerow(out_row)
