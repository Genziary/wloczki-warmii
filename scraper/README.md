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

5. Fill the `.env` file based on `.env.example` with credentials, debug mode loads only one page of products
```
API_KEY=<api-key>
API_URL=http://localhost:8000/api/
DEBUG=True
```

6. Run prestashop in debugging mode
```
PS_DEV_MODE=1 docker compose up
```

7. Change shop domain in back office (Preferences > Traffic) to `localhost:8000`

8. Run the script
```
python load.py
```

9. Now you can change shop domain back to previous value
