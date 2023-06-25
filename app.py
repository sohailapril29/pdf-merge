from flask import Flask, request
from PyPDF2 import PdfMerger

app = Flask(__name__)

@app.route('/merge', methods=['POST'])
def merge_pdfs():
    pdf_files = request.files.getlist('pdfFiles[]')

    merger = PdfMerger()

    for pdf_file in pdf_files:
        merger.append(pdf_file)

    output_pdf = 'merged.pdf'
    merger.write(output_pdf)
    merger.close()

    return f'Merged PDF file created: <a href="{output_pdf}" target="_blank">{output_pdf}</a>'

if __name__ == '__main__':
    app.run(debug=True)
