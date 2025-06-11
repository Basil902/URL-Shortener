FROM python:3.12
COPY requirements.txt /redirectapp/requirements.txt
WORKDIR /redirectapp
EXPOSE 5002
RUN pip install -r requirements.txt
COPY . /redirectapp
ENTRYPOINT [ "python" ]
CMD [ "run.py" ]