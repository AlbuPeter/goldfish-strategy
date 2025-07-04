let currentLang = localStorage.getItem('lang') || 'en';

  // Fordítások
  const translations = {
    hu: {
      netWorth: 'Nettó vagyon (USDC)',
      totalInvested: 'Befektetett összeg (USDC)'
    },
    en: {
      netWorth: 'Net Worth (USDC)',
      totalInvested: 'Total Invested (USDC)'
    },
    de: {
      netWorth: 'Nettovermögen (USDC)',
      totalInvested: 'Insgesamt investiert (USDC)'
    },
    fr: {
      netWorth: 'Valeur nette (USDC)',
      totalInvested: 'Total investi (USDC)'
    }
  };

  // Fordítási függvény
  function translate(key) {
    return translations[currentLang]?.[key] || key;
  }


async function loadChart() {
  const res = await fetch('api/get-portfolio-history.php');
  const text = await res.text();

  let data;
  try {
    data = JSON.parse(text);
    if (!Array.isArray(data)) {
      console.error("⚠️ A kapott válasz nem tömb:", data);
      return; // Megállítja a grafikont
    }
  } catch (err) {
    console.error("❌ Nem érvényes JSON válasz:", text);
    throw err;
  }


  // Csak hónap-nap formátumot használunk a címkéknél
  const labels = data.map(d => {
    const date = new Date(d.recorded_at);
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    return `${month}-${day}`;
  });

  const totalValues = data.map(d => d.total_value);
  const investedValues = data.map(d => d.invested);

  const ctx = document.getElementById('portfolioChart').getContext('2d');

  const chart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [
        {
          label: translate('netWorth'),
          data: totalValues,
          borderColor: '#D4A437',
          fill: false
        },
        {
          label: translate('totalInvested'),
          data: investedValues,
          borderColor: 'rgb(63, 35, 3)',
          fill: false
        }
      ]
    },
    options: {
      responsive: true,
      scales: {
        x: {
          ticks: {
            maxRotation: 0,
            minRotation: 0
          }
        }
      }
    }
  });
}

loadChart();
