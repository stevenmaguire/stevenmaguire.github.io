import csv
import os
import re

li = ['opensource', 'projects', 'theatre']

for s in li:
    directory = '_' + s
    if not os.path.exists(directory):
        os.makedirs(directory)
    with open(s + '.csv') as f:
        reader = csv.DictReader(f)
        for row in reader:
            filename = re.sub('[ ]', '-', re.sub('[^A-Za-z0-9\- ]+', '', row['name'])).lower()
            if os.path.exists(directory + "/" + filename + ".md"):
                filename += "_1";
            filename += ".md"
            #print filename
            content = "---" + "\n"
            for p in row.iteritems():
                content += p[0] + ": \"" + p[1] + "\"\n"
            content += "---" + "\n"

            # print content
            fileToWrite = open(directory + "/" + filename, 'w')

            fileToWrite.write(content)
