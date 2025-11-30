using Microsoft.AspNetCore.Mvc;
using CreditCalculator.Models;

namespace CreditCalculator.Controllers
{
    /// <summary>
    /// Kontroler odpowiedzialny za obliczenia kalkulatora kredytowego
    /// </summary>
    public class CalcController : Controller
    {
        /// <summary>
        /// Wyświetla formularz (GET)
        /// </summary>
        public IActionResult Index()
        {
            return View(new CalcForm());
        }

        /// <summary>
        /// Odbiera dane z formularza i oblicza wynik (POST)
        /// </summary>
        [HttpPost]
        [ValidateAntiForgeryToken]
        public IActionResult Calculate(CalcForm form)
        {
            if (!ModelState.IsValid)
            {
                return View("Index", form);
            }

            try
            {
                CalcResult result = CalculateCredit(form);

                return View("Result", new { Form = form, Result = result });
            }
            catch (Exception ex)
            {
                ModelState.AddModelError("", Messages.CALC_ERROR + ": " + ex.Message);
                return View("Index", form);
            }
        }

        /// <summary>
        /// Prywatna metoda do wykonania obliczeń kredytowych
        /// </summary>
        private CalcResult CalculateCredit(CalcForm form)
        {
            decimal monthlyRate = form.InterestRate / 100 / 12;

            if (monthlyRate == 0)
            {
                decimal monthlyPayment = form.Amount / form.Months;
                return new CalcResult
                {
                    MonthlyPayment = monthlyPayment,
                    TotalPayment = form.Amount,
                    TotalInterest = 0,
                    AnnualPayment = monthlyPayment * 12
                };
            }

            // Wzór na ratę: P = (K * r * (1 + r)^n) / ((1 + r)^n - 1)
            decimal raisedRate = (decimal)Math.Pow((double)(1 + monthlyRate), form.Months);
            decimal monthlyPayment2 = (form.Amount * monthlyRate * raisedRate) / (raisedRate - 1);

            decimal totalPayment = monthlyPayment2 * form.Months;
            decimal totalInterest = totalPayment - form.Amount;

            return new CalcResult
            {
                MonthlyPayment = Math.Round(monthlyPayment2, 2),
                TotalPayment = Math.Round(totalPayment, 2),
                TotalInterest = Math.Round(totalInterest, 2),
                AnnualPayment = Math.Round(monthlyPayment2 * 12, 2)
            };
        }
    }
}
