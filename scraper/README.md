1. Create venv
```
python -m venv venv
```

2. Activate venv
```
source venv/bin/activate
```

3. Install dependencies

```
pip install -r requirements.txt

```

4. In admin panel in advanced settings generate api key with product related permissions

5. Fill the .env file with credentials, debug mode loads only one page of products
```
API_KEY=<api-key>
API_URL=<api-url>
DEBUG=True
```

6. Run prestashop in debugging mode
```
PS_DEV_MODE=1 docker-compose up
```

7. Run the script
```
python load.py
```
