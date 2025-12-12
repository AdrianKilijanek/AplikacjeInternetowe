using Microsoft.AspNetCore.Identity.EntityFrameworkCore;
using Microsoft.EntityFrameworkCore;
using CreditCalculator.Models;

namespace CreditCalculator.Data
{
    public class ApplicationDbContext : IdentityDbContext   // <-- ważne
    {
        public ApplicationDbContext(DbContextOptions<ApplicationDbContext> options)
            : base(options)
        {
        }

        public DbSet<CreditCalculation> CreditCalculations { get; set; }
    }
}
