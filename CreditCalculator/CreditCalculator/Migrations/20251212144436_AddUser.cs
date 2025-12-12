using Microsoft.EntityFrameworkCore.Migrations;

#nullable disable

namespace CreditCalculator.Migrations
{
    /// <inheritdoc />
    public partial class AddUser : Migration
    {
        /// <inheritdoc />
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.AddColumn<string>(
                name: "UserId",
                table: "CreditCalculations",
                type: "nvarchar(450)",
                nullable: true);

            migrationBuilder.CreateIndex(
                name: "IX_CreditCalculations_UserId",
                table: "CreditCalculations",
                column: "UserId");

            migrationBuilder.AddForeignKey(
                name: "FK_CreditCalculations_AspNetUsers_UserId",
                table: "CreditCalculations",
                column: "UserId",
                principalTable: "AspNetUsers",
                principalColumn: "Id");
        }

        /// <inheritdoc />
        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropForeignKey(
                name: "FK_CreditCalculations_AspNetUsers_UserId",
                table: "CreditCalculations");

            migrationBuilder.DropIndex(
                name: "IX_CreditCalculations_UserId",
                table: "CreditCalculations");

            migrationBuilder.DropColumn(
                name: "UserId",
                table: "CreditCalculations");
        }
    }
}
