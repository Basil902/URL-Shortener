FROM python:3.12
COPY requirements.txt /shortenapp/requirements.txt
WORKDIR /shortenapp
RUN pip install -r requirements.txt
COPY . /shortenapp
ENTRYPOINT [ "python" ]
CMD [ "run.py" ]