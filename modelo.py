import pandas as pd
from sklearn.ensemble import RandomForestRegressor
import sys, os

base = os.path.dirname(os.path.abspath(__file__))
ruta = os.path.join(base, "storage", "app", "private", "datos.csv")

if not os.path.exists(ruta):
    print("0,0,0,0")
    exit()

df = pd.read_csv(ruta)

df = df.dropna()
df = df[df['total'] >= 0]

if len(df) < 3:
    print("0,0,0,0")
    exit()

df['dia'] = pd.to_datetime(df['dia'])
df['dia_num'] = range(len(df))
df['dia_semana'] = df['dia'].dt.dayofweek

X = df[['dia_num', 'dia_semana']]
y = df['total']

model = RandomForestRegressor(n_estimators=100)
model.fit(X, y)

pred_dia = model.predict([[len(df), (len(df) % 7)]])[0]
pred_semana = pred_dia * 7
pred_mes = pred_dia * 30

media = df['total'].mean()
std = df['total'].std()
outliers = df[df['total'] > media + 2*std]

print(f"{pred_dia},{pred_semana},{pred_mes},{len(outliers)}")