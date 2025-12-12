using System.ComponentModel.DataAnnotations.Schema;
using Microsoft.AspNetCore.Identity;

namespace CreditCalculator.Models
{
    public class CreditCalculation
    {
        public int Id { get; set; }

        [Column(TypeName = "decimal(18,2)")]
        public decimal Amount { get; set; }

        [Column(TypeName = "decimal(5,2)")]
        public decimal InterestRate { get; set; }

        [Column(TypeName = "decimal(18,2)")]
        public decimal MonthlyPayment { get; set; }

        public int Months { get; set; }
        public DateTime CreatedAt { get; set; } = DateTime.UtcNow;

        // powiązanie z użytkownikiem
        public string? UserId { get; set; }
        public IdentityUser? User { get; set; }
    }
}