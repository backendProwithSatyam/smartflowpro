import Layout from "@/Components/layout/Layout";
import Authenticated from "@/Layouts/AuthenticatedLayout";

const Dashboard = () => {
  return (
    <Authenticated>
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div className="bg-white p-6 rounded-2xl shadow">
          <h2 className="text-lg font-semibold">Total Customers</h2>
          <p className="text-3xl font-bold mt-2">120</p>
        </div>
        <div className="bg-white p-6 rounded-2xl shadow">
          <h2 className="text-lg font-semibold">Pending Invoices</h2>
          <p className="text-3xl font-bold mt-2">15</p>
        </div>
        <div className="bg-white p-6 rounded-2xl shadow">
          <h2 className="text-lg font-semibold">Revenue</h2>
          <p className="text-3xl font-bold mt-2">₹ 2,45,000</p>
        </div>
      </div>
    </Authenticated>
  );
};

export default Dashboard;
